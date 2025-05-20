package tp0.metier;

public class TD00ImplementationDiagramme {
    public static void main(String[] args) {
        // 1. Création des marques
        Marque marque1 = new Marque(1,"Audi");
        Marque marque2 = new Marque(2, "BMW");

        // 2. Création des modèles
        Berline berline5pt80ch = new Berline(1, 950, 5, 80, 5, marque1);
        Berline berline2pt100ch = new Berline(2, 950, 2, 100, 5, marque1);
        Berline berline5pt100ch = new Berline(3, 950, 5, 100, 5, marque1);
        Berline berline5pt120ch = new Berline(4, 950, 5, 120, 5, marque1);
        Berline berline5pt120chmarque2 = new Berline(5, 950, 5, 120, 5, marque2);

       marque1.getModeles().add(berline5pt80ch);
       marque1.getModeles().add(berline2pt100ch);
       marque1.getModeles().add(berline5pt100ch);
       marque1.getModeles().add(berline5pt120ch);
       marque2.getModeles().add(berline5pt120chmarque2);

        
        
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
    }
}
