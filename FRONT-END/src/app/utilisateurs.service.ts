import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UtilisateursServiceService {
  private apiUrl = 'http://127.0.0.1:8000/api/utilisateurs/save'; // Base URL for API

  constructor(private http: HttpClient) { }

  inscription(utilisateur: any): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/save`, utilisateur);
  }
}
