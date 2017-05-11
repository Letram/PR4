;;------------------------------- 1
(define (principio lst)
    (cond
        ((null? lst) lst)
        (else (cons (car lst) (principioAux (cdr lst) (car lst))))
    )
)
(define(principioAux lst v)
    (cond
        ((null? lst)lst)
        ((eqv? (car lst) v) (cons (car lst) (principioAux (cdr lst) v)))
        (else '())
    )
)

;;------------------------------- 2
(define (profundidad lst v)
    (cond
        ((null? lst) 0)
        ((list? (car lst)) (if (equal? 0 (profundidad (car lst) v))
                               (profundidad (cdr lst) v)
                               (+ 1 (profundidad (car lst) v))
                               ))
        ((equal? (car lst) v) 1)
        (else (profundidad (cdr lst) v))
    )
)