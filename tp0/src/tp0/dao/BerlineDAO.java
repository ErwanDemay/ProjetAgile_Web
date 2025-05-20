/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package tp0.dao;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Set;
import tp0.dao.ConnexionMysql;
import tp0.metier.Berline;
import tp0.metier.TD00ImplementationDiagramme;

import tp0.metier.Marque;
import tp0.metier.Berline;
import tp0.metier.Modele;




/**
 *
 * @author Utilisateur
 */
public class BerlineDAO extends ConnexionMysql{
    public BerlineDAO(String theDriver, String theBDD, String theUser,  String thePwd){
        super(theDriver, theBDD, theUser,  thePwd);
    }
    
    public boolean ajouter(Berline uneBerline){
        
        try {
            String requete = "INSERT INTO `berline`(`id`, `nom`, `nbPortes`, `puissance`, `poids`, `nbPersonnes`, `idMarque`)"
              + "VALUES ("+uneBerline.getId()+",'"+uneBerline.getNom()+"',"+uneBerline.getNbPortes()+","+uneBerline.getPuissance()+","+uneBerline.getPoids()+","+uneBerline.getNbPersonnes()+","+uneBerline.getMaMarque().getId()+");";

            Statement state = cnx.createStatement();
            state.executeUpdate(requete);

            System.out.println("La berline vient d'être ajoutée : ");
            return true;

        } catch (SQLException e) {
            System.out.println("La berline N'a PAS pu être ajoutée : ");e.printStackTrace();
            return false; 
        }
    }
    
    
    public ArrayList<Berline> getLesBerlines(){
        
        try {
            String requete = "SELECT * FROM berline;";
            Statement state = cnx.createStatement();
            ResultSet lesLignes = state.executeQuery(requete);
            
            ArrayList<Berline> tabLesLignes = new ArrayList();
            
            while(lesLignes.next()) {
                Marque uneMarque = new Marque(lesLignes.getInt(7), "Non renseigne");
                Berline unExempleDeBerline = new Berline(lesLignes.getInt(1), lesLignes.getInt(2), lesLignes.getInt(3), lesLignes.getInt(4), lesLignes.getInt(5),uneMarque);
                tabLesLignes.add(unExempleDeBerline);
            }
            lesLignes.close(); 
            
            return tabLesLignes;

        } catch (SQLException e) {
            System.out.println("La berline N'a PAS pu être ajoutée : ");e.printStackTrace();
            return null; 
        }
    }
    
    
    public void close() throws SQLException{
        this.cnx.close();
    }
    
    
}
