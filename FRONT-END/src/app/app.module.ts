import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { ConnexionComponent } from './connexion/connexion.component';
import { HttpClientModule } from '@angular/common/http';
import { TableauComponent } from './tableau/tableau.component';
import { FichierComponent } from './fichier/fichier.component';
import { UtilisateursComponent } from './utilisateurs/utilisateurs.component';
import { FormsModule } from '@angular/forms';
import { ListeComponent } from './liste/liste.component'; // Importez FormsModule ici

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    ConnexionComponent,
    TableauComponent,
    FichierComponent,
    UtilisateursComponent,
    ListeComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule // Make sure HttpClientModule is imported here if you're using HttpClient
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
