/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package DAL;

import java.sql.Connection;
import java.sql.DriverManager;
import javax.swing.JOptionPane;

/**
 *
 * @author Aki
 */
public class DataAcessHelper {
    protected Connection con;
    String drive ="com.microsoft.sqlserver.jdbc.SQLServerDriver";
    String urdb="jdbc:sqlserver://127.0.0.1:1433;databaseName=master";
    String user="sa";
    String pass="123456";
    
    public void getConnect()
    {
        try {
            Class.forName(drive);
        } catch (Exception e) {
        e.printStackTrace();
        }
        try {
            con=DriverManager.getConnection(urdb,user,pass);
        } catch (Exception e) {
            JOptionPane.showMessageDialog(null,"Không thể kết nối tới CSDL");
        }
    }
    public void getClose()
    {
        try {
            con.close();
        } catch (Exception e) {
            JOptionPane.showMessageDialog(null, "Không thể đóng kết nối tới CSDL");
        }
    }
}
