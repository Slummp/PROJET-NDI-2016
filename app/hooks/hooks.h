#ifndef _APP_HOOKS_H
#define _APP_HOOKS_H

#include <core/HTTP/header/header.h>

extern int hook_root (HTTP_header_t *header);
extern int hook_register (HTTP_header_t *header);

#endif