package tp0.metier;

import java.util.ArrayList;
import tp0.dao.BerlineDAO;
import tp0.dao.UtilitaireDAO;

public class TD00ImplementationDiagramme {
    public static void main(String[] args) {
        // 1. Création des marques
        Marque marque1 = new Marque(1,"Audi");
        Marque marque2 = new Marque(2, "BMW");

        // 2. Création des modèles
        Berline berline5pt80ch = new Berline(2,"nom", 5 , 120, 500,marque1,4);
        

       marque1.getModeles().add(berline5pt80ch);
  

        
        
        // 4. Affichage des modèles de la marque 1
        System.out.println("Modeles de la marque " + marque1.getNom() + " :");
        for (Modele modele : marque1.getModeles()) {
            System.out.println("- " + modele.getInfos());
        }
        // 5. Affichage des modèles de la marque 1 avec 5 portes et puissance >= 100ch
        System.out.println("\nModeles de la marque " + marque1.getNom() + " avec 5 portes et puissance 100ch :");
        for (Modele modele : marque1.getModeles()) {
            if (modele.getNbPortes() == 5 && modele.getPuissance() >= 100) {
                System.out.println("- " + modele.getInfos());
            }
        }
        
BerlineDAO berlineDAO = new BerlineDAO("jdbc:mysql://localhost:3306/", "sio2_tdo_industrieauto", "root", "");


//ajout avec la première méthode 
/*
berlineDAO.ajouter(berline5pt80ch);
*/
ArrayList<Berline> maListe;
maListe = berlineDAO.getLesBerlines();





//ajout de la berline avec la deuxième méthode ajouter2 qui a 9 champs
/*
Berline berlineAjouter2 = new Berline(254,"nom", 5 , 120, 500,marque1,4);
if (berlineDAO.ajouter2(berlineAjouter2)) {  
    System.out.println("Ajout réussi !");
} else {
    System.out.println("Échec de l'ajout.");
}
*/

/*
Berline berlineAjouter3 = new Berline(800,"labelleberline", 2000 , 5, 120,marque1,4);
if (berlineDAO.ajouter2(berlineAjouter3)) {  
    System.out.println("Ajout réussi !");
} else {
    System.out.println("Échec de l'ajout.");
}
*/

UtilitaireDAO utilitaireDAO = new UtilitaireDAO("jdbc:mysql://localhost:3306/", "sio2_tdo_industrieauto", "root", "");
Utilitaire utilitaireAjouter2 = new Utilitaire(58,"berlinedefou",2000,5,300,marque1,2000,1000);
if(utilitaireDAO.ajouter2(utilitaireAjouter2)){
    System.out.println("Ajout réussi! ");
}else {
    System.out.println("Echec de l'ajout.");
}


for (Berline berline : maListe){
    System.out.println("nom : "+berline.getNom());
    System.out.println("id : " + berline.getId());
}
        
        
    }
}
