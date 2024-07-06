import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs'

@Injectable({
  providedIn: 'root'
})
export class UtilisateursServiceService {
  private apiUrl = 'http://127.0.0.1:8000/api/utilisateurs/save'; // Remplacez par votre URL API Larave

  constructor(private http: HttpClient) { 
    

  }
}
