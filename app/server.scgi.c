#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <ccgi.h>
#include <glib.h>

#include "core/HTTP/header/header.h"

void CGI_cb (void) {
  HTTP_header_t *header = HTTP_header_create();
  
  GString *route = g_string_new(getenv("SCRIPT_NAME"));
  g_string_erase(route, 0, strlen("/association"));

  int status = 200;
  if (strcmp(route->str, "/") == 0) {
  	HTTP_header_set(header, CONTENT_TYPE, "text/html");
  	HTTP_header_send(header);
  	printf("Route: %s\n", route->str);
  } else if (strcmp(route->str, "/register") == 0) {
  	HTTP_header_set(header, CONTENT_TYPE, "text/html");
  	HTTP_header_send(header);
  	printf("Route: %s\n", route->str);
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
  }

  g_string_free(route, TRUE);
  HTTP_header_destroy(header);
}

int main (void) {
  CGI_prefork_server("localhost", 4000, "/var/run/projet-ndi-2016-scgi.pid",
		     100, 8, 16, 1000, &CGI_cb);
  return EXIT_FAILURE;
}
