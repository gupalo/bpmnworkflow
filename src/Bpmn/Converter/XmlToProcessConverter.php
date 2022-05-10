<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Converter;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Process\Process;
use Gupalo\BpmnWorkflow\Bpmn\SymbolResolver\Resolver;
use Gupalo\BpmnWorkflow\Bpmn\Validator\FacadeValidator;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbol;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbolContainer;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbolContainerBuilder;

class XmlToProcessConverter
{
    public function process(string $content): array
    {
        $xml = (new XmlLoader())->load($content);
        $container = (new XmlSymbolContainerBuilder())->build($xml);
        (new FacadeValidator())->validate($container);
        $processes = [$this->getProcess($container, $container->getFirstStartEvent())];
        foreach ($container->getLinksCatch() as $linkCatch) {
            $processes[$linkCatch->getData()] = $this->getProcess($container, $linkCatch);
        }

        return $processes;
    }
    
    private function getProcess(XmlSymbolContainer $container, XmlSymbol $start): Process
    {
        $process = new Process();
        (new Resolver($container))->resolve($process, $start);
        
        return $process;
    }
}
