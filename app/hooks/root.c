#include "hooks.h"
#include <views.h>

int hook_root (HTTP_header_t *header) {
	HTTP_header_set(header, CONTENT_TYPE, "text/html");
	HTTP_header_send(header);
	VIEW(view_asso,
		"HELLO WORLD!", "Boisson, poisson", "Voici une superbe description\net multiligne en plus", "ex@example.com", "06", "127 chemin de la poire", "http://lafistinière.com", "http://facebook.com", "");
	return 200;	
}