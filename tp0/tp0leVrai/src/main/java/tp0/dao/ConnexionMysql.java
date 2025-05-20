/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package tp0.dao;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author Utilisateur
 */
public class ConnexionMysql {
    /*
    
    */
    static Connection cnx=null;
    


    
    public ConnexionMysql(String theDriver, String theBDD, String theUser,  String thePwd){
        
        // Établissement de la connexion
        try {
            String theUrl = theDriver + theBDD;
            cnx = DriverManager.getConnection(theUrl, theUser, thePwd);
            System.out.println("Connexion à la base de données MySQL établie avec succès !");
 
        } catch (SQLException e) {
            System.out.println("Erreur lors de la connexion à la base de données MySQL : " + e.getMessage());
        }
    }
    

    

    
}
