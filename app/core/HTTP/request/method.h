#ifndef _APP_CORE_HTTP_REQUEST_METHOD_H
#define _APP_CORE_HTTP_REQUEST_METHOD_H

typedef enum { GET, POST, PUT, PATCH, DELETE } HTTP_request_method_t;

extern int HTTP_request_method_get (HTTP_request_method_t *buf);

#endif
