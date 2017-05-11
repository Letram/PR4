(define (final lst)
    ;;if the list is empty we cant do nothing
    (if (null? lst)
        lst
        ;;if the list has only one element, we return it
        (if (null? (cdr lst))
            lst
            ;;if not, we compare the actual element with the element in the "final" list
            (if (equal? (car lst) (car (final (cdr lst))))
                ;;if it is equal AND it is in the next position of our list, we append it.
                ;;i.e. lst = (1 2 3 *1 1 1), final = (1 1) -> iff *1 is equal to
                ;;our list and it is on the next position we compare, we append it.
                (if (= (length lst) (+ 1 (length (final (cdr lst)))))
                    (cons (car lst) (final (cdr lst)))
                    ;;if not, we just go on
                    (final (cdr lst))
                )
                (final (cdr lst))
            )
        )
    )
)

(define (profundidad lst)
    ;;if it is a list, we continue going that way
    (if (list? lst)
        ;;if it is null we just advance one level
        (if (null? lst)
            1
            ;;if it has one member, we calculate its depth
            (if (null? (cdr lst))
                (+ 1 (profundidad (car lst)))
                ;;if not, we compare the depth of the first member with the rest of the list
                (if (< (profundidad (car lst)) (profundidad (cdr lst)))
                    (profundidad (cdr lst))
                    (+ 1 (profundidad (car lst)))
                )
            )
        )
        0
    )
)