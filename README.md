<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

###############
TEST POSTMAN
###############
- http://localhost:8000/api/auth/login

- Nella scheda "Body", seleziona "raw" e "JSON"

- Inserisci le credenziali reparto it:
{
  "email": "luca@test.test",
  "password": "reparto1"
}


- Inserisci le credenziali dipendente:
{
  "email": credenziali dipendente create con faker, controlalre nel db,
  "password": "dipendente1"
}


creare nuovo tiket POST
Nella scheda "Body", seleziona "raw" e "JSON"
http://localhost:8000/api/tickets

{
  "titolo": "Problema con la stampante",
  "descrizione": "La stampante dell'ufficio non funziona correttamente."
}

----------------------------------------------------------
----------------------------------------------------------
ESEMPIO
- Crea una nuova richiesta GET a http://localhost:8000/api/tickets
- Se sei loggato come rep_it, vedrai tutti i ticket
- Se sei loggato come dipendente, vedrai solo i tuoi ticket


-------------------------------------------------------------
-------------------------------------------------------------
JWT
---REQUEST TOKEN JWT
POST -> http://localhost:8000/api/auth/login richiesta token