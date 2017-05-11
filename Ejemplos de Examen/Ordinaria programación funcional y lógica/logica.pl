final([H], H).
final([], []).
final([H|T],[H]):-
    final(T,[]).
final([H|T], [X|R]):-
    X \= [],
    X \= H,
    final(T, [X|R]).
final([H|T], [H,H|R]):-
    T = [S|_],
    S = H,
    final(T, [H|R]).
final([H|T], [X|R]):-
    T = [S|_],
    S \= H,
    final(T, [X|R]).

profundidad([], 1).
profundidad(A, 0) :- 
    not(is_list(A)).
profundidad([H|T], N) :-
    H = [],
    profundidad(T, N1),
    N is N1+1.
profundidad([H|T], N) :-
    H \= [],
    profundidad(H, N1),
    profundidad(T, N2),
    N3 is N1+1,
    N3 > N2,
    N is N3.
profundidad([H|T], N) :-
    H \= [],
    profundidad(H, N1),
    profundidad(T, N2),
    N3 is N1+1,
    N3 =< N2,
    N is N2.
    

    