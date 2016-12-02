
(load "/opt/local/stow/sbcl-1.3.3-x86-64-linux/lib/sbcl/quicklisp/quicklisp/setup.lisp")
(ql:quickload 'cl-markdown)
(cl-markdown:markdown "# Hello *there*")
