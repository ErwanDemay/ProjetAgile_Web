/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package tp0.metier;


/**
 *
 * @author erwan
 */
public class Berline extends Modele {
 private int nbPersonnesMax;

    public Berline(int id,String nom,int poids,int nbPortes,int nbChevaux,Marque marque,int nbPersonnesMax) {
        super(id,nom,poids,nbPortes,nbChevaux,marque);
        this.nbPersonnesMax = nbPersonnesMax;
    }

    public int getNbPersonnes() {
        return nbPersonnesMax;
    }
    

 
    
}
