<?php

namespace Gupalo\BpmnWorkflow\Bpmn\Converter;

use Gupalo\BpmnWorkflow\Bpmn\Symbol\Process\Process;
use Gupalo\BpmnWorkflow\Bpmn\SymbolResolver\Resolver;
use Gupalo\BpmnWorkflow\Bpmn\Validator\FacadeValidator;
use Gupalo\BpmnWorkflow\Bpmn\XmlSymbol\XmlSymbolContainerBuilder;

class XmlToProcessConverter
{
    public function process(string $content): Process
    {
        $xml = (new XmlLoader())->load($content);
        $container = (new XmlSymbolContainerBuilder())->build($xml);
        (new FacadeValidator())->validate($container);
        $process = new Process();
        (new Resolver($container))->resolve($process, $container->getFirstStartEvent());

        return $process;
    }

}
