principio([],[]).
principio([N],[N]).
principio([H|T], [H]) :-
    principio(T, [X|_]), H \= X.
principio([H|T], [H,H|P]) :- 
    principio(T, [X|P]), X=H.
    
profundidad([],_,0).
profundidad([H|_], H, 1).
profundidad([H|_], V, N):-
    is_list(H),
    V \= H,
    profundidad(H, V, N1),
    N is N1+1,
    !.
profundidad([H|T], V, N):-
    V \= H,
    profundidad(T, V, N), 
    !.