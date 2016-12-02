#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include "header.h"

#define NUMBER_OF_KEYS 16

struct HTTP_header_s {
    struct {
        _Bool isset;
        const char *value;
    } data[NUMBER_OF_KEYS];
};

HTTP_header_t *HTTP_header_create (void) {
    HTTP_header_t *header = malloc(sizeof (struct HTTP_header_s));
    if (header != NULL) {
        for (int i = 0 ; i < NUMBER_OF_KEYS ; i++)
            header->data[i].isset = 0;
    }

    return header;
}

void HTTP_header_destroy (HTTP_header_t *header) {
    free(header);
}

const char *HTTP_header_get (const HTTP_header_t *header, enum HTTP_header_e key) {
    return (header->data[key].isset ? header->data[key].value : NULL);
}

int HTTP_header_set (HTTP_header_t *header, enum HTTP_header_e key, const char *value) {
    int status = (header->data[key].isset ? 0 : 1);
    header->data[key].isset = 1;
    header->data[key].value = strdup(value);

    return status;
}

_Bool HTTP_header_isset (const HTTP_header_t *header, enum HTTP_header_e key) {
    return header->data[key].isset;
}

void HTTP_header_send (const HTTP_header_t *header) {
    static const char *skey[NUMBER_OF_KEYS] = {
        [ACCESS_CONTROL_ALLOW_ORIGIN] = "Access-Control-Allow-Origin",
        [ALLOW] = "Allow",
        [CACHE_CONTROL] = "Cache-Control",
        [CONTENT_DISPOSITION] = "Content-Disposition",
        [CONTENT_ENCODING] = "Content-Encoding",
        [CONTENT_LANGUAGE] = "Content-Language",
        [CONTENT_TYPE] = "Content-Type",
        [DATE] = "Date",
        [EXPIRES] = "Expires",
        [LAST_MODIFIED] = "Last-Modified",
        [LOCATION] = "Location",
        [REFRESH] = "Refresh",
        [RETRY_AFTER] = "Retry-After",
        [SET_COOKIE] = "Set-Cookie",
        [STATUS] = "Status",
        [UPGRADE] = "Upgrade"
    };

    for (int i = 0 ; i < NUMBER_OF_KEYS ; i++) {
        if (!header->data[i].isset)
            continue ;
        printf("%s: %s\r\n", skey[i], header->data[i].value);
    }
    fputs("\r\n", stdout);
}
