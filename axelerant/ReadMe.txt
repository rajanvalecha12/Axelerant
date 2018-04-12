Please find below the URL where you can dynamically change content type and node id
 by altering last two parameter in the URL respectively :

http://localhost/page_json/{content_type}/{node_id}

 URL above responds with a JSON representation of the given node with the content type "page" only if the previously 
submitted API Key and node id (nid) of an appropriate node are present, otherwise it will respond with
 "access denied".


When logged in as the administrator, the "Site API Key" can be added at the path
 /admin/config/system/site-information.


