<?php


namespace components;


abstract class ControllerAbstract
{
    private ?string $controllerPath;
    private ?string $actionPath;

    /**
     * @return string|null
     */
    public function getActionPath(): ?string
    {
        return $this->actionPath;
    }

    /**
     * @param string|null $actionPath
     */
    public function setActionPath(?string $actionPath): void
    {
        $this->actionPath = $actionPath;
    }

    /**
     * @return string|null
     */
    public function getControllerPath(): ?string
    {
        return $this->controllerPath;
    }

    /**
     * @param string|null $controllerPath
     */
    public function setControllerPath(?string $controllerPath): void
    {
        $this->controllerPath = $controllerPath;
    }


}