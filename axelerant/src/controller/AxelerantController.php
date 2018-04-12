<?php

namespace Drupal\axelerant\Controller;

use Drupal\Core\Access\AccessResult;
use Symfony\Component\HttpFoundation\Response;

/**
 * This is the controller class that contains display and access logic
 */

class AxelerantController {

    /**
     * 
     * @param type $type
     * content type
     * @param type $nid
     * node id of the node
     * @return Response
     * Response Object returning Json Response
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     * Access Denied for invalide node ID's and content type
     */
    public function display($type, $nid) {
         //nid is numeric or not
        $nid = is_numeric($nid) ? $nid : FALSE;
        if ($nid) {
            $result = db_select('node', 'n')
                            ->fields('n')
                            ->condition('type', $type, '=')
                            ->condition('nid', $nid, '=')
                            ->execute()->fetchAll()['0']->nid;
            //load node if a node with nid exists
            if (isset($result) && !empty($result)) {
                $node = node_load($result);
            }
            //Show the JSON data if the node exist otherwise show 403 access denied
            if (!empty($node)) {
                //Return the data as JSON
                $nrm = new \Drupal\Component\Serialization\Json;
                $json = $nrm->encode($node->toArray(), 'json');

                return new Response($json);
            } else {
                //show 403 access denied
                throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
            }
        } else {
            echo "Please enter the numeric value";
            die;
        }
    }

    /**
     * 
     * @return type
     * access permission for the JSON URL
     */
    public function access() {
        //Get the Site API Key
        $site_api_key = \Drupal::config('system.site')->get('siteapikey');
        //If $site_api_key exist and not empty grant access to the URL
        return AccessResult::allowedIf(isset($site_api_key) && !empty($site_api_key));
    }

}
