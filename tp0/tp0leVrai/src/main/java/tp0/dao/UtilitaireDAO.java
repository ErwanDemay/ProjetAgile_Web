/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package tp0.dao;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import static tp0.dao.ConnexionMysql.cnx;


import tp0.metier.Marque;
import tp0.metier.Berline;
import tp0.metier.Utilitaire;




/**
 *
 * @author Utilisateur
 */
public class UtilitaireDAO extends ConnexionMysql{
    public UtilitaireDAO(String theDriver, String theBDD, String theUser,  String thePwd){
        super(theDriver, theBDD, theUser,  thePwd);
    }
    
    
    
    public boolean ajouter2(Utilitaire unUtilitaire) {
    try {
       String requete = "INSERT INTO `modele`(`id`, `nom`, `nbPortes`, `nbChevaux`, `poids`, `idMarque`, `type`, `PTAC`, `volumeUtile`) "
                + "VALUES (" + unUtilitaire.getId() + ", '" + unUtilitaire.getNom() + "', "
                + unUtilitaire.getNbPortes() + ", " + unUtilitaire.getPuissance() + ", "
                + unUtilitaire.getPoids() + ", " + unUtilitaire.getMarque().getId() + ", "
                + "'utilitaire', " + unUtilitaire.getPTAC() + ", " + unUtilitaire.getVolumeUtile() + ");";

        
        Statement state = cnx.createStatement();
        state.executeUpdate(requete);
        
        System.out.println("L'utilitaire vient d'être ajoutée");
        return true;
    } catch (SQLException e) {
        System.out.println("L'utilitaire n'a pas pu être ajouté: ");
        e.printStackTrace();
        return false;
    }
}   
    public void close() throws SQLException{
        this.cnx.close();
    }
    
    
}
