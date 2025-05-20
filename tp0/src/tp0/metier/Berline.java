/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package tp0.metier;
import tp0.metier.Modele;

/**
 *
 * @author erwan
 */
public class Berline extends Modele {
 private int nbPersonnesMax;

    public Berline(int id,int poids, int nbPortes, int nbChevaux,int nbPersonnesMax,Marque marque) {
        super(id,poids, nbPortes, nbChevaux,nbPersonnesMax,marque);
        this.nbPersonnesMax = nbPersonnesMax;
    }

    public int getNbPersonnes() {
        return nbPersonnesMax;
    }
    
    public int getNbPortes(){
        return super.getNbPortes();
    }
    
    public int getPoids(){
        return super.getPoids();
    }
    
    public Marque getMaMarque(){
        return marque;
    }
    

 
    
}
