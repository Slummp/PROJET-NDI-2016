#include <ccgi.h>
#include <core/session/session.h>


extern void add_bdd();
extern _Bool exist_in_bdd(int id);
extern void create_in_bdd(int id);
struct session_s {
  _Bool is_new;
  long id;
};

static int search_new_id()
{
    int id;
    do{
	id=rand();
    }while(!exist_in_bdd(id));
    return id;
}

session_t* session_start (HTTP_header_t *header)
{
  session_t* session=malloc(sizeof(*session));
  CGI_varlist* varlist=CGI_get_cookie(NULL);
  char *value;
  if(varlist!=NULL)
  {
      value=CGI_lookup(varlist,"session");
      if(value!=NULL)
      {
	  int id=atoi(*varlist);
	  if(exist_in_bdd(id))
	  {
	      session->id=id;
	      session->is_new=0;
	      return session;
	  }
      }
  }
  session->exist_in_bdd=1;
  session->id=search_new_id();
  create_in_bdd(session->id);
  return session;
}

extern _Bool session_is_new(const session_t *session)
{
  return session->is_new;
}
