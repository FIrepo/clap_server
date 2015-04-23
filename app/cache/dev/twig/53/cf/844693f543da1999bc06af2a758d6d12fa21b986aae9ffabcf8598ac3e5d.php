<?php

/* VclapApiUserBundle:Default:index.html.twig */
class __TwigTemplate_53cf844693f543da1999bc06af2a758d6d12fa21b986aae9ffabcf8598ac3e5d extends Twig_Template
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
