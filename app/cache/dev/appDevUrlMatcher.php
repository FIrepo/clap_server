<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        // unregistertoken
        if (0 === strpos($pathinfo, '/unregistertoken') && preg_match('#^/unregistertoken(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_unregistertoken;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'unregistertoken')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\UserController::unregistertokenAction',  '_format' => NULL,));
        }
        not_unregistertoken:

        // getuseractions
        if (0 === strpos($pathinfo, '/getuseractions') && preg_match('#^/getuseractions(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_getuseractions;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getuseractions')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\UserController::getuseractionsAction',  '_format' => NULL,));
        }
        not_getuseractions:

        // login
        if (0 === strpos($pathinfo, '/login') && preg_match('#^/login(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_login;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'login')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\UserController::loginAction',  '_format' => NULL,));
        }
        not_login:

        if (0 === strpos($pathinfo, '/finduserby')) {
            // finduserbyemail
            if (0 === strpos($pathinfo, '/finduserbyemail') && preg_match('#^/finduserbyemail(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_finduserbyemail;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'finduserbyemail')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\UserController::finduserbyemailAction',  '_format' => NULL,));
            }
            not_finduserbyemail:

            // finduserbytoken
            if (0 === strpos($pathinfo, '/finduserbytoken') && preg_match('#^/finduserbytoken(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_finduserbytoken;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'finduserbytoken')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\UserController::finduserbytokenAction',  '_format' => NULL,));
            }
            not_finduserbytoken:

            // finduserbyname
            if (0 === strpos($pathinfo, '/finduserbyname') && preg_match('#^/finduserbyname(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_finduserbyname;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'finduserbyname')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\UserController::finduserbynameAction',  '_format' => NULL,));
            }
            not_finduserbyname:

            // finduserbyid
            if (0 === strpos($pathinfo, '/finduserbyid') && preg_match('#^/finduserbyid(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_finduserbyid;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'finduserbyid')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\UserController::finduserbyidAction',  '_format' => NULL,));
            }
            not_finduserbyid:

        }

        if (0 === strpos($pathinfo, '/searchuser')) {
            // searchuserbyname
            if (0 === strpos($pathinfo, '/searchuserbyname') && preg_match('#^/searchuserbyname(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_searchuserbyname;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'searchuserbyname')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\UserController::searchuserbynameAction',  '_format' => NULL,));
            }
            not_searchuserbyname:

            // searchuser
            if (preg_match('#^/searchuser(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_searchuser;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'searchuser')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\UserController::searchuserAction',  '_format' => NULL,));
            }
            not_searchuser:

            // searchuserbyage
            if (0 === strpos($pathinfo, '/searchuserbyage') && preg_match('#^/searchuserbyage(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_searchuserbyage;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'searchuserbyage')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\UserController::searchuserbyageAction',  '_format' => NULL,));
            }
            not_searchuserbyage:

        }

        // createuser
        if (0 === strpos($pathinfo, '/createuser') && preg_match('#^/createuser(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_createuser;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'createuser')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\UserController::createuserAction',  '_format' => NULL,));
        }
        not_createuser:

        // updateuser
        if (0 === strpos($pathinfo, '/updateuser') && preg_match('#^/updateuser(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_updateuser;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'updateuser')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\UserController::updateuserAction',  '_format' => NULL,));
        }
        not_updateuser:

        if (0 === strpos($pathinfo, '/fileoperations')) {
            // fileoperations
            if (rtrim($pathinfo, '/') === '/fileoperations') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'fileoperations');
                }

                return array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\FileController::indexAction',  '_route' => 'fileoperations',);
            }

            // uploadfile
            if ($pathinfo === '/fileoperations/upload') {
                return array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\FileController::uploadAction',  '_route' => 'uploadfile',);
            }

        }

        if (0 === strpos($pathinfo, '/getmycontact')) {
            // getmycontacts
            if (0 === strpos($pathinfo, '/getmycontacts') && preg_match('#^/getmycontacts(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_getmycontacts;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getmycontacts')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\ContactsController::getmycontactsAction',  '_format' => NULL,));
            }
            not_getmycontacts:

            // getmycontacted
            if (0 === strpos($pathinfo, '/getmycontacted') && preg_match('#^/getmycontacted(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_getmycontacted;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getmycontacted')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\ContactsController::getmycontactedAction',  '_format' => NULL,));
            }
            not_getmycontacted:

        }

        // addcontact
        if (0 === strpos($pathinfo, '/addcontact') && preg_match('#^/addcontact(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_addcontact;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'addcontact')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\ContactsController::addcontactAction',  '_format' => NULL,));
        }
        not_addcontact:

        if (0 === strpos($pathinfo, '/re')) {
            // removecontact
            if (0 === strpos($pathinfo, '/removecontact') && preg_match('#^/removecontact(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_removecontact;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'removecontact')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\ContactsController::removecontactAction',  '_format' => NULL,));
            }
            not_removecontact:

            // reportabuse
            if (0 === strpos($pathinfo, '/reportabuse') && preg_match('#^/reportabuse(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_reportabuse;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'reportabuse')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\MessageController::reportabuseAction',  '_format' => NULL,));
            }
            not_reportabuse:

        }

        // messageupdateread
        if (0 === strpos($pathinfo, '/messageupdateread') && preg_match('#^/messageupdateread(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_messageupdateread;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'messageupdateread')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\MessageController::messageupdatereadAction',  '_format' => NULL,));
        }
        not_messageupdateread:

        if (0 === strpos($pathinfo, '/getconversationhistory')) {
            // getconversationhistorycount
            if (0 === strpos($pathinfo, '/getconversationhistorycount') && preg_match('#^/getconversationhistorycount(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_getconversationhistorycount;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getconversationhistorycount')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\MessageController::getconversationhistorycountAction',  '_format' => NULL,));
            }
            not_getconversationhistorycount:

            // getconversationhistory
            if (preg_match('#^/getconversationhistory(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_getconversationhistory;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getconversationhistory')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\MessageController::getconversationhistoryAction',  '_format' => NULL,));
            }
            not_getconversationhistory:

        }

        // deletemessage
        if (0 === strpos($pathinfo, '/deletemessage') && preg_match('#^/deletemessage(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_deletemessage;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletemessage')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\MessageController::deletemessageAction',  '_format' => NULL,));
        }
        not_deletemessage:

        // setmessagedelete
        if (0 === strpos($pathinfo, '/setmessagedelete') && preg_match('#^/setmessagedelete(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_setmessagedelete;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'setmessagedelete')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\MessageController::setmessagedeleteAction',  '_format' => NULL,));
        }
        not_setmessagedelete:

        // addnewmessage
        if (0 === strpos($pathinfo, '/addnewmessage') && preg_match('#^/addnewmessage(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_addnewmessage;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'addnewmessage')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\MessageController::addnewmessageAction',  '_format' => NULL,));
        }
        not_addnewmessage:

        // getusermessages
        if (0 === strpos($pathinfo, '/getusermessages') && preg_match('#^/getusermessages(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_getusermessages;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getusermessages')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\MessageController::getusermessagesAction',  '_format' => NULL,));
        }
        not_getusermessages:

        // addcomment
        if (0 === strpos($pathinfo, '/addcomment') && preg_match('#^/addcomment(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_addcomment;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'addcomment')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\MessageController::addcommentAction',  '_format' => NULL,));
        }
        not_addcomment:

        if (0 === strpos($pathinfo, '/get')) {
            if (0 === strpos($pathinfo, '/getcomments')) {
                // getcommentscount
                if (0 === strpos($pathinfo, '/getcommentscount') && preg_match('#^/getcommentscount(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                        goto not_getcommentscount;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getcommentscount')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\MessageController::getcommentscountAction',  '_format' => NULL,));
                }
                not_getcommentscount:

                // getcomments
                if (preg_match('#^/getcomments(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                        goto not_getcomments;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getcomments')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\MessageController::getcommentsAction',  '_format' => NULL,));
                }
                not_getcomments:

            }

            // getgroupmessages
            if (0 === strpos($pathinfo, '/getgroupmessages') && preg_match('#^/getgroupmessages(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_getgroupmessages;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getgroupmessages')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\MessageController::getgroupmessagesAction',  '_format' => NULL,));
            }
            not_getgroupmessages:

            // getavatar
            if (0 === strpos($pathinfo, '/getavatar') && preg_match('#^/getavatar(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_getavatar;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getavatar')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\MessageController::getavatarAction',  '_format' => NULL,));
            }
            not_getavatar:

        }

        // subscribegroup
        if (0 === strpos($pathinfo, '/subscribegroup') && preg_match('#^/subscribegroup(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_subscribegroup;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'subscribegroup')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::subscribegroupAction',  '_format' => NULL,));
        }
        not_subscribegroup:

        // unsubscribegroup
        if (0 === strpos($pathinfo, '/unsubscribegroup') && preg_match('#^/unsubscribegroup(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_unsubscribegroup;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'unsubscribegroup')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::unsubscribegroupAction',  '_format' => NULL,));
        }
        not_unsubscribegroup:

        if (0 === strpos($pathinfo, '/get')) {
            // getgroupsbyuserid
            if (0 === strpos($pathinfo, '/getgroupsbyuserid') && preg_match('#^/getgroupsbyuserid(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_getgroupsbyuserid;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getgroupsbyuserid')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::getgroupsbyuseridAction',  '_format' => NULL,));
            }
            not_getgroupsbyuserid:

            if (0 === strpos($pathinfo, '/getallusers')) {
                // getalluserscountbygroupid
                if (0 === strpos($pathinfo, '/getalluserscountbygroupid') && preg_match('#^/getalluserscountbygroupid(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                        goto not_getalluserscountbygroupid;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getalluserscountbygroupid')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::getalluserscountbygroupidAction',  '_format' => NULL,));
                }
                not_getalluserscountbygroupid:

                // getallusersbygroupid
                if (0 === strpos($pathinfo, '/getallusersbygroupid') && preg_match('#^/getallusersbygroupid(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                        goto not_getallusersbygroupid;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getallusersbygroupid')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::getallusersbygroupidAction',  '_format' => NULL,));
                }
                not_getallusersbygroupid:

            }

        }

        // creategroupcategory
        if (0 === strpos($pathinfo, '/creategroupcategory') && preg_match('#^/creategroupcategory(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_creategroupcategory;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'creategroupcategory')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::creategroupcategoryAction',  '_format' => NULL,));
        }
        not_creategroupcategory:

        if (0 === strpos($pathinfo, '/getallgroupc')) {
            // getallgroupcount
            if (0 === strpos($pathinfo, '/getallgroupcount') && preg_match('#^/getallgroupcount(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_getallgroupcount;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'getallgroupcount')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::getallgroupcountAction',  '_format' => NULL,));
            }
            not_getallgroupcount:

            if (0 === strpos($pathinfo, '/getallgroupcategor')) {
                // getallgroupcategorycount
                if (0 === strpos($pathinfo, '/getallgroupcategorycount') && preg_match('#^/getallgroupcategorycount(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                        goto not_getallgroupcategorycount;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getallgroupcategorycount')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::getallgroupcategorycountAction',  '_format' => NULL,));
                }
                not_getallgroupcategorycount:

                if (0 === strpos($pathinfo, '/getallgroupcategories')) {
                    // getallgroupcategories
                    if (preg_match('#^/getallgroupcategories(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                            goto not_getallgroupcategories;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'getallgroupcategories')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::getallgroupcategoriesAction',  '_format' => NULL,));
                    }
                    not_getallgroupcategories:

                    // getallgroupcategoriesbypage
                    if (0 === strpos($pathinfo, '/getallgroupcategoriesbypage') && preg_match('#^/getallgroupcategoriesbypage(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                            goto not_getallgroupcategoriesbypage;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'getallgroupcategoriesbypage')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::getallgroupcategoriesbypageAction',  '_format' => NULL,));
                    }
                    not_getallgroupcategoriesbypage:

                }

            }

        }

        if (0 === strpos($pathinfo, '/find')) {
            // findgroupbyid
            if (0 === strpos($pathinfo, '/findgroupbyid') && preg_match('#^/findgroupbyid(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_findgroupbyid;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'findgroupbyid')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::findgroupbyidAction',  '_format' => NULL,));
            }
            not_findgroupbyid:

            // findallgroups
            if (0 === strpos($pathinfo, '/findallgroups') && preg_match('#^/findallgroups(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_findallgroups;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'findallgroups')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::findallgroupsAction',  '_format' => NULL,));
            }
            not_findallgroups:

            // findgroupbycategoryid
            if (0 === strpos($pathinfo, '/findgroupbycategoryid') && preg_match('#^/findgroupbycategoryid(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_findgroupbycategoryid;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'findgroupbycategoryid')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::findgroupbycategoryidAction',  '_format' => NULL,));
            }
            not_findgroupbycategoryid:

            // findcategorybycategoryid
            if (0 === strpos($pathinfo, '/findcategorybycategoryid') && preg_match('#^/findcategorybycategoryid(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_findcategorybycategoryid;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'findcategorybycategoryid')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::findcategorybycategoryidAction',  '_format' => NULL,));
            }
            not_findcategorybycategoryid:

            // findgroupbyname
            if (0 === strpos($pathinfo, '/findgroupbyname') && preg_match('#^/findgroupbyname(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_findgroupbyname;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'findgroupbyname')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::findgroupbynameAction',  '_format' => NULL,));
            }
            not_findgroupbyname:

        }

        // updategroup
        if (0 === strpos($pathinfo, '/updategroup') && preg_match('#^/updategroup(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_updategroup;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'updategroup')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::updategroupAction',  '_format' => NULL,));
        }
        not_updategroup:

        // creategroup
        if (0 === strpos($pathinfo, '/creategroup') && preg_match('#^/creategroup(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_creategroup;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'creategroup')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::creategroupAction',  '_format' => NULL,));
        }
        not_creategroup:

        if (0 === strpos($pathinfo, '/deletegroup')) {
            // deletegroupcategory
            if (0 === strpos($pathinfo, '/deletegroupcategory') && preg_match('#^/deletegroupcategory(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_deletegroupcategory;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletegroupcategory')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::deletegroupcategoryAction',  '_format' => NULL,));
            }
            not_deletegroupcategory:

            // deletegroup
            if (preg_match('#^/deletegroup(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                    goto not_deletegroup;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletegroup')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::deletegroupAction',  '_format' => NULL,));
            }
            not_deletegroup:

        }

        // updategroupcategory
        if (0 === strpos($pathinfo, '/updategroupcategory') && preg_match('#^/updategroupcategory(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_updategroupcategory;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'updategroupcategory')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GroupController::updategroupcategoryAction',  '_format' => NULL,));
        }
        not_updategroupcategory:

        // changepassword
        if (0 === strpos($pathinfo, '/changepassword') && preg_match('#^/changepassword(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_changepassword;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'changepassword')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GeneralController::changepasswordAction',  '_format' => NULL,));
        }
        not_changepassword:

        // forgotpassword
        if (0 === strpos($pathinfo, '/forgotpassword') && preg_match('#^/forgotpassword(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_forgotpassword;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'forgotpassword')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GeneralController::forgotpasswordAction',  '_format' => NULL,));
        }
        not_forgotpassword:

        // getlastloginuserscount
        if (0 === strpos($pathinfo, '/getlastloginuserscount') && preg_match('#^/getlastloginuserscount(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_getlastloginuserscount;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'getlastloginuserscount')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\GeneralController::getlastloginuserscountAction',  '_format' => NULL,));
        }
        not_getlastloginuserscount:

        // createstory
        if (0 === strpos($pathinfo, '/createstory') && preg_match('#^/createstory(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_createstory;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'createstory')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\StoryController::createstoryAction',  '_format' => NULL,));
        }
        not_createstory:

        if (0 === strpos($pathinfo, '/get')) {
            if (0 === strpos($pathinfo, '/getstoryco')) {
                // getstorycommentcount
                if (0 === strpos($pathinfo, '/getstorycommentcount') && preg_match('#^/getstorycommentcount(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                        goto not_getstorycommentcount;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getstorycommentcount')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\StoryController::getstorycommentcountAction',  '_format' => NULL,));
                }
                not_getstorycommentcount:

                // getstorycount
                if (0 === strpos($pathinfo, '/getstorycount') && preg_match('#^/getstorycount(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                        goto not_getstorycount;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getstorycount')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\StoryController::getstorycountAction',  '_format' => NULL,));
                }
                not_getstorycount:

                // getstorycomments
                if (0 === strpos($pathinfo, '/getstorycomments') && preg_match('#^/getstorycomments(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                        goto not_getstorycomments;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getstorycomments')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\StoryController::getstorycommentsAction',  '_format' => NULL,));
                }
                not_getstorycomments:

            }

            if (0 === strpos($pathinfo, '/getallstories')) {
                // getallstoriesbykey
                if (0 === strpos($pathinfo, '/getallstoriesbykey') && preg_match('#^/getallstoriesbykey(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                        goto not_getallstoriesbykey;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getallstoriesbykey')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\StoryController::getallstoriesbykeyAction',  '_format' => NULL,));
                }
                not_getallstoriesbykey:

                // getallstories
                if (preg_match('#^/getallstories(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                        goto not_getallstories;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getallstories')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\StoryController::getallstoriesAction',  '_format' => NULL,));
                }
                not_getallstories:

            }

        }

        // deletestory
        if (0 === strpos($pathinfo, '/deletestory') && preg_match('#^/deletestory(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_deletestory;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'deletestory')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\StoryController::deletestoryAction',  '_format' => NULL,));
        }
        not_deletestory:

        // addstorycomment
        if (0 === strpos($pathinfo, '/addstorycomment') && preg_match('#^/addstorycomment(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_addstorycomment;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'addstorycomment')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\StoryController::addstorycommentAction',  '_format' => NULL,));
        }
        not_addstorycomment:

        // updatestory
        if (0 === strpos($pathinfo, '/updatestory') && preg_match('#^/updatestory(?:\\.(?P<_format>rss|xml|json|html))?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('POST', 'GET', 'HEAD'))) {
                $allow = array_merge($allow, array('POST', 'GET', 'HEAD'));
                goto not_updatestory;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'updatestory')), array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\StoryController::updatestoryAction',  '_format' => NULL,));
        }
        not_updatestory:

        if (0 === strpos($pathinfo, '/emoticon')) {
            // uploademticon
            if ($pathinfo === '/emoticon/addemoticon') {
                return array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\EmoticonController::addemoticonAction',  '_route' => 'uploademticon',);
            }

            // updateemoticon
            if ($pathinfo === '/emoticon/updateemoticon') {
                return array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\EmoticonController::updateemoticonAction',  '_route' => 'updateemoticon',);
            }

            if (0 === strpos($pathinfo, '/emoticon/get')) {
                // emoticoncount
                if ($pathinfo === '/emoticon/getemoticoncount') {
                    return array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\EmoticonController::getemoticoncountAction',  '_route' => 'emoticoncount',);
                }

                // getallemoticons
                if ($pathinfo === '/emoticon/getallemoticons') {
                    return array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\EmoticonController::getallemoticonsAction',  '_route' => 'getallemoticons',);
                }

                // emoticongetbyid
                if ($pathinfo === '/emoticon/getemoticonbyid') {
                    return array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\EmoticonController::getemoticonbyidAction',  '_route' => 'emoticongetbyid',);
                }

                // getallemoticonsbypaging
                if ($pathinfo === '/emoticon/getallemoticonsbypaging') {
                    return array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\EmoticonController::getallemoticonsbypagingAction',  '_route' => 'getallemoticonsbypaging',);
                }

                if (0 === strpos($pathinfo, '/emoticon/getemoticon')) {
                    // getemoticonimagebyid
                    if ($pathinfo === '/emoticon/getemoticonimagebyid') {
                        return array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\EmoticonController::getemoticonimagebyidAction',  '_route' => 'getemoticonimagebyid',);
                    }

                    // getemoticonbyidentifier
                    if ($pathinfo === '/emoticon/getemoticonbyidentifier') {
                        return array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\EmoticonController::getemoticonbyidentifierAction',  '_route' => 'getemoticonbyidentifier',);
                    }

                }

            }

            // emoticondeletebyid
            if ($pathinfo === '/emoticon/deleteemoticonbyid') {
                return array (  '_controller' => 'Vclap\\Api\\UserBundle\\Controller\\EmoticonController::deleteemoticonbyidAction',  '_route' => 'emoticondeletebyid',);
            }

        }

        // homepage
        if ($pathinfo === '/app/example') {
            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage',);
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
