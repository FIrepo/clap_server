<?php

/* VclapApiUserBundle:Default:index.html.twig */
class __TwigTemplate_db744696a58649ba2036a7955a74a4fe67b8c3ea1c0215ffea60376466bf253a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo twig_escape_filter($this->env, (isset($context["data"]) ? $context["data"] : $this->getContext($context, "data")), "html", null, true);
        echo "
";
    }

    public function getTemplateName()
    {
        return "VclapApiUserBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
