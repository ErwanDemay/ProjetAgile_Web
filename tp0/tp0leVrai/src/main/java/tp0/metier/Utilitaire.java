/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package tp0.metier;

/**
 *
 * @author erwan
 */
public class Utilitaire extends Modele {
    private int PTAC;
    private int volumeUtile;
    
    public Utilitaire(int id,String nom,int poids,int nbPortes,int nbChevaux,Marque marque,int PTAC , int volumeUtile){
        super(id,nom,poids,nbPortes,nbChevaux,marque);
        this.PTAC = PTAC;
        this.volumeUtile = volumeUtile;
    }

    public int getPTAC() {
        return PTAC;
    }

    public int getVolumeUtile() {
        return volumeUtile;
    }
    
    
   
    
}
