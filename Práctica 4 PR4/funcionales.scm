(define (fibo n)
    (cond
        ((eqv? n 0) 0)
        ((eqv? n 1) 1)
        (else (+ (fibo (- n 1)) (fibo (- n 2))))
    )
)

(define (expo b n)
    (if (eqv? n 0)
        1
        (* b (expo b (- n 1)))
    )
)

(define (minimo lst)
    (cond
        ((null? (cdr lst)) (car lst))
        ((< (car lst) (minimo (cdr lst))) (car lst))
        (else (minimo (cdr lst)))
    )
)

(define (inserta n lst)
    (cond
        ((null? lst) (cons n '()))
        ((> n (car lst)) (cons (car lst) (inserta n (cdr lst))))
        (else (cons n lst))
    )
)

(define (concatena lst1 lst2)
    (cond
        ((null? lst1) lst2)
        ((null? lst2) lst1)
        (else (cons (car lst1) (concatena (cdr lst1) lst2)))
    )
)

(define (invierte lst)
    (cond
        ((null? lst) lst)
        (else (concatena (invierte (cdr lst)) (cons (car lst) '())))
    )
)

(define (elimina data lst)
    (cond
        ((null? lst) lst)
        ((equal? data (car lst)) (elimina data (cdr lst)))
        (else (cons (car lst) (elimina data (cdr lst))))
    )
)

(define (repetidos lst)
    (cond
        ((null? lst) lst)
        ((in? (car lst) (cdr lst)) (repetidos (cdr lst)))
        (else (cons (car lst) (repetidos (cdr lst))))
    )
)

(define (in? data lst)
    (cond
        ((null? lst) #f)
        ((equal? data (car lst)) #t)
        (else (in? data (cdr lst)))
    )
)