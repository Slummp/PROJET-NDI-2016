#include <stdio.h>
#include <unistd.h>
#include <assert.h>
#include <signal.h>
#include <sys/wait.h>

static int fd=-1;
static int pid=-1;
void init_lisp()
{
  int tab[2];
  pipe(tab);
  if(!(pid=fork())){
    dup2(tab[0],STDIN_FILENO);
    close(tab[1]);
    execlp("sbcl","sbcl","--noinform","--noprint","--disable-debugger","--load","markdown.lisp",NULL);
  }else{
    fd=tab[1];
    close(tab[0]);
    waitpid(pid,NULL,WUNTRACED);
    
  }
}

void markdown(char* str){
  assert(fd!=-1);
  kill(pid,SIGCONT);
  dprintf(fd,"(markdown \"%s\")\n",str);
  waitpid(pid,NULL,WUNTRACED);
}
