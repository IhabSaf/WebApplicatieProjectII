<?php
namespace FrameWork\Event;
class KernelEvent
{
    const KERNEL_REQUEST = "kernel.request";
    const KERNEL_CONTROLLER = "kernel.controller";
    const KERNEL_VIEW = "kernel.view";
    const KERNEL_RESPONSE = "kernel.response";
    const KERNEL_TERMINATE = "kernel.terminate";
}