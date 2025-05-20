/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package tp0.metier;

/**
 *
 * @author erwan
 */
public class Modele {
    private int id;
    private String nom;
    private int poids;
    private int nbPortes;
    private int nbChevaux;
    public Marque marque;
    
     public Modele(int id,String nom, int poids, int nbPortes, int nbChevaux,Marque marque) {
        this.id = id;
        this.nom = nom;
        this.poids = poids;
        this.nbPortes = nbPortes;
        this.nbChevaux = nbChevaux;
        this.marque = marque;
    }

    public int getId() {
        return id;
    }
    
    public String getNom(){
        return nom;
    }
    
    public int getPuissance(){
        return nbChevaux;
    }
    
    public int getNbPortes(){
        return nbPortes;
    }
    
    public int getPoids(){
        return poids;
    }
    
    public Marque getMarque(){
        return marque;
    }
    
    
    
    public String getInfos(){
                return marque.getNom() + " - " + getPuissance() + "ch " + getNbPortes() + " portes";
    }
   


  



  
     
     
}



