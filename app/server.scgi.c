#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <ccgi.h>
#include <glib.h>

#include "core/HTTP/header/header.h"
#include "hooks/hooks.h"
#include <app/views.h>

void CGI_cb (void) {
	HTTP_header_t *header = HTTP_header_create();
  
  	GString *route = g_string_new(getenv("SCRIPT_NAME"));
  	g_string_erase(route, 0, strlen("/association"));
  	if ((route->len > 1) && (route->str[route->len - 1] == '/'))
  		g_string_erase(route, route->len - 1, 1);

  	int status = 200;
  	if (strcmp(route->str, "/") == 0) {
	    status = hook_root(header);
  	} else if (strcmp(route->str, "/register") == 0) {
  		status = hook_register(header);
  	} else {
  		status = 404;
  	}

  	if (status > 200) {
  		HTTP_header_set(header, CONTENT_TYPE, "text/html");
		  switch (status) {
	  		case 404:
	  			HTTP_header_set(header, STATUS, "404 Not Found");
	  			break ;
	  		case 405:
	  			HTTP_header_set(header, STATUS, "405 Method Not Allowed");
	  			break ;
		  }
		  HTTP_header_send(header);
      VIEW(error, status);
  	}

  	g_string_free(route, TRUE);
  	HTTP_header_destroy(header);
}

int main (void) {
  	CGI_prefork_server("localhost", 4000, "/var/run/projet-ndi-2016-scgi.pid",
		     			100, 8, 16, 1000, &CGI_cb);
  	return EXIT_SUCCESS;
}
