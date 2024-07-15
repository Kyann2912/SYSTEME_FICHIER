// import { Injectable } from '@angular/core';

// @Injectable({
//   providedIn: 'root'
// })
// export class UtilisateursService {

//   constructor() { }
// }

// utilisateurs.service.ts
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UtilisateursService {
  private apiUrl = 'http://localhost:8000/api/utilisateurs'; // URL de votre API Laravel

  constructor(private http: HttpClient) {}

  // Méthode pour enregistrer un utilisateur
  registerUser(userData: any): Observable<any> {
    return this.http.post<any>(this.apiUrl, userData);
  }
}

