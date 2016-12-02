#include <stdlib.h>
#include <stdio.h>
#include <ccgi.h>


#include "core/HTTP/header/header.h"

void CGI_cb (void) {
  HTTP_header_t *header = HTTP_header_create();
  HTTP_header_set(header, CONTENT_TYPE, "text/html");
  HTTP_header_send(header);
  printf("Hello world !");
  HTTP_header_destroy(header);
}

int main (void) {
  CGI_prefork_server("localhost", 4000, "/var/run/projet-ndi-2016-scgi.pid",
		     100, 8, 16, 1000, &CGI_cb);
  return EXIT_FAILURE;
}
