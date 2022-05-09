<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Converter;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Process\Process;
use Gupalo\BpmnWorkflow\Bpmn\SymbolResolver\Resolver;
use Gupalo\BpmnWorkflow\Bpmn\Validator\FacadeValidator;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbolContainerBuilder;

class XmlToProcessConverter
{
    public function process(string $content): array
    {
        $xml = (new XmlLoader())->load($content);
        $container = (new XmlSymbolContainerBuilder())->build($xml);
        (new FacadeValidator())->validate($container);
        $processes = [];
        $process = new Process();
        (new Resolver($container))->resolve($process, $container->getFirstStartEvent());
        $processes['default'] = $process;
        foreach ($container->getLinkCatch() as $linkCatch) {
            $process = new Process();
            (new Resolver($container))->resolve($process, $linkCatch);    
            $processes[$linkCatch->getData()] = $process;
        }

        return $processes;
    }
}
