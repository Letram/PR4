%---------------------- 1  
fibo(0, 0).
fibo(1, 1).
fibo(N, R) :-
    N>1,
    N1 is N-1,
    N2 is N-2,
    fibo(N1, R1),
    fibo(N2, R2),
    R is R1+R2.
%---------------------- 2      
expo(_,0,1).
expo(B,E,V) :-
    E>=1,
    E1 is E-1,
    expo(B, E1, V1),
    V is B*V1.
%---------------------- 3     
minimo([Min], Min).
minimo([H,K|T], Min) :-
    H =< K,
    minimo([H|T], Min).
minimo([H,K|T], Min) :-
    H > K,
    minimo([K|T], Min).
%---------------------- 4  
inserta([], V, [V]).
inserta([H|T], V, [H|T]) :-
    H=:=V.
inserta([H|T], V, [V,H|T]) :-
    H > V.
inserta([H|T], V, [H|T2]) :-
    H < V,
    inserta(T, V, T2).
%---------------------- 5  
invierte([], []).
invierte([H|T], L) :-
    invierte(T, S),
    append(S, [H], L).
%---------------------- 6      
elimina([X], V, []) :-
    X =:= V.
elimina([X], V, [X]) :-
    X =\= V.
elimina([H|T], V, E) :-
    H =:= V,
    elimina(T, V, E).
elimina([H|T], V, E) :-
    H =\= V,
    elimina(T, V, F),
    append([H], F, E).
%---------------------- 7  
repetidos([], []).
repetidos([H|T], L) :-
    in(H, T),
    !,
    repetidos(T, L).
repetidos([H|T], [H|L]) :-
    repetidos(T, L).
    
in(V, [V|_]):-!.
in(V, [_|T]):-
    in(V,T).




































