import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-tableau',
  templateUrl: './tableau.component.html',
  styleUrl: './tableau.component.css'
})
export class TableauComponent {
  constructor(private router: Router) { }

    redirectToPage(event: any) {
        const selectedOption = event.target.value;

        // if (selectedOption === 'telecharger') {
        //     // Rediriger vers la page de téléchargement
        //     this.router.navigate(['/inscription']);
        // }
        if (selectedOption === 'ajouter') {
            // Rediriger vers la page d'ajout de fichier
            this.router.navigate(['/fichier']);
        }
        if (selectedOption === 'liste') {
          // Rediriger vers la page d'ajout de fichier
          this.router.navigate(['/liste']);
      }
    }

}
