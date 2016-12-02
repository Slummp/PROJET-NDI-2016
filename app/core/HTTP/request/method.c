#include <stdlib.h>
#include <string.h>
#include "method.h"

int HTTP_request_method_get (HTTP_request_method_t *buf) {
    static struct {
        const char *smethod;
        HTTP_request_method_t method;
    } assoc[] = {
        { .smethod = "GET",    .method = GET    },
        { .smethod = "POST",   .method = POST   },
        { .smethod = "PUT",    .method = PUT    },
        { .smethod = "PATCH",  .method = PATCH  },
        { .smethod = "DELETE", .method = DELETE },
    };

    *buf = (HTTP_request_method_t)-1;
    const char *smethod = getenv("REQUEST_METHOD");
    
    for (int i = 0 ; i < 5 ; i++) {
        if (strcmp(assoc[i].smethod, smethod) == 0) {
            *buf = assoc[i].method;
            break ;
        }
    }

    return ((*buf) == (HTTP_request_method_t)-1) ? -1 : 0 ;
}
