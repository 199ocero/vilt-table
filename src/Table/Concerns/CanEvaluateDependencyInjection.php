<?php

namespace JAOcero\ViltTable\Table\Concerns;

use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;
use ReflectionFunction;
use ReflectionNamedType;
use ReflectionParameter;

trait CanEvaluateDependencyInjection
{
    public function evaluate(mixed $value, array $namedInjections = [], array $typedInjections = []): mixed
    {
        if ($value instanceof Closure) {
            $dependencies = [];
            $parameters = (new ReflectionFunction($value))->getParameters();

            foreach ($parameters as $parameter) {
                $dependencies[] = $this->resolveClosureDependencyEvaluation($parameter, $namedInjections, $typedInjections);
            }

            return $value(...$dependencies);
        }

        return $value;
    }

    protected function resolveClosureDependencyEvaluation(ReflectionParameter $parameter, array $namedInjections, array $typedInjections): mixed
    {
        // Resolve by name
        $parameterName = $parameter->getName();
        if (array_key_exists($parameterName, $namedInjections)) {
            return value($namedInjections[$parameterName]);
        }

        // Resolve by type
        $parameterType = $parameter->getType();
        if ($parameterType instanceof ReflectionNamedType && ! $parameterType->isBuiltin()) {
            $parameterClassName = $parameterType->getName();
            if (array_key_exists($parameterClassName, $typedInjections)) {
                return value($typedInjections[$parameterClassName]);
            }
        }

        // Get the declaring class and function/method where the parameter is defined
        $declaringClass = $parameter->getDeclaringClass();
        $declaringFunction = $parameter->getDeclaringFunction();
        $declaringClassName = $declaringClass->getName();
        $declaringFunctionName = $declaringFunction->getName();
        $declaringFunctionLine = $declaringFunction->getStartLine();

        // Construct context information for the exception message
        $context = '';
        if ($declaringClassName && $declaringFunctionName && $declaringFunctionLine) {
            $context = " in class [{$declaringClassName}] and function [{$declaringFunctionName}] at line [{$declaringFunctionLine}]";
        } elseif ($declaringFunctionName && $declaringFunctionLine) {
            $context = " in function [{$declaringFunctionName}] at line [{$declaringFunctionLine}]";
        }

        // Throw an exception with a detailed message
        throw new BindingResolutionException("An attempt was made to evaluate a closure but the parameter [\${$parameterName}] was unresolvable{$context}.");
    }
}
