/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package tp0.metier;

import java.util.ArrayList;

/**
 *
 * @author erwan
 */
public class Marque {
    private int id;
    private String nom; 
    private ArrayList<Modele> modeles;

    public Marque(int id, String nom) {
        this.id = id;
        this.nom = nom;
        this.modeles = new ArrayList<>();
    }
    
    public int getId(){
        return id;
    }
    
    public String getNom(){
        return nom;
    }
    
    
 
    
    public ArrayList<Modele> getModeles(){
        return modeles;
    }
    
}
