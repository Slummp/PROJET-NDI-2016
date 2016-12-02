
(load "~/quicklisp/setup.lisp")
(ql:quickload 'cl-markdown)
(ql:quickload 'cffi)


(defun markdown (str)
  (cl-markdown:markdown str)
  (finish-output nil)
  (cffi:foreign-funcall "kill"
		       :int (cffi:foreign-funcall "getpid"
						  :int)
		       :int 19
		       :int))


(cffi:foreign-funcall "kill"
		     :int (cffi:foreign-funcall "getpid"
						:int)
		     :int 19
		     :int)



