import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { ConnexionComponent } from './connexion/connexion.component';
import { TableauComponent } from './tableau/tableau.component';
import { FichierComponent } from './fichier/fichier.component';
import { UtilisateursComponent } from './utilisateurs/utilisateurs.component';








const routes: Routes = [
  { path: '', component: HomeComponent },
  { path: 'connexion', component: ConnexionComponent },
  { path: 'tableau', component: TableauComponent },
  { path: 'fichier', component: FichierComponent },
  { path: 'utilisateurs', component: UtilisateursComponent },


];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }


