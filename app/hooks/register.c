#include "hooks.h"
#include <views.h>

int hook_register (HTTP_header_t *header) {
	HTTP_header_set(header, CONTENT_TYPE, "text/html");
	HTTP_header_send(header);
	VIEW(new_asso);
	return 200;
}