<?php
/*
 * PHP-Nuke CE (Community Edition / Custom Edition)
 * Project name in-code: nukeCE
 */

namespace NukeCE\Core;

use RuntimeException;

final class ModuleManager
{
    /** @var array<string, ModuleInterface> */
    private array $modules = [];

    public function __construct(private string $modulesPath)
    {
        $this->modulesPath = rtrim($this->modulesPath, '/\\');
    }

    public function getModule(string $name): ModuleInterface
    {
        $name = strtolower(preg_replace('/[^a-z0-9_\-]/i', '', $name) ?? $name);
        \1

        // Optional-module gate (default-off)
        $manifest = @include __DIR__ . '/../../includes/modules_manifest.php';
        $enabledOpt = [];
        $enabledFile = __DIR__ . '/../../config/ENABLED_OPTIONAL_MODULES.php';
        if (is_file($enabledFile)) {
            $tmp = @include $enabledFile;
            if (is_array($tmp)) { $enabledOpt = array_map('strtolower', $tmp); }
        }
        if (is_array($manifest) && isset($manifest['optional']) && is_array($manifest['optional'])) {
            $optional = array_map('strtolower', $manifest['optional']);
            if (in_array($name, $optional, true) && !in_array($name, $enabledOpt, true)) {
                throw new RuntimeException("Module '$name' is optional and not enabled");
            }
        }

if (isset($this->modules[$name])) {
            return $this->modules[$name];
        }

        $className = $this->classNameFor($name);
        $classFile = $this->fileFor($name);

        if (!is_file($classFile)) {
            throw new RuntimeException("Module '$name' not found");
        }

        require_once $classFile;

        if (!class_exists($className)) {
            throw new RuntimeException("Module class '$className' does not exist");
        }

        $module = new $className();

        if (!$module instanceof ModuleInterface) {
            throw new RuntimeException("Module '$name' must implement ModuleInterface");
        }

        $this->modules[$name] = $module;
        return $module;
    }

    private function fileFor(string $name): string
    {
        $dir = $this->modulesPath . '/' . $name;
        $base = $this->studly($name) . 'Module.php';
        return $dir . '/' . $base;
    }

    private function classNameFor(string $name): string
    {
        $studly = $this->studly($name);
        return "NukeCE\\Modules\\{$studly}\\{$studly}Module";
    }

    private function studly(string $s): string
    {
        $s = str_replace(['-','_'], ' ', $s);
        $s = ucwords($s);
        return str_replace(' ', '', $s);
    }
}
