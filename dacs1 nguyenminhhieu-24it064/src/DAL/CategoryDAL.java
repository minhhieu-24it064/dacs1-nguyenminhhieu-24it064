/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package DAL;

import Entity.Category;
//import com.sun.corba.se.spi.presentation.rmi.PresentationManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;
import javax.swing.JOptionPane;

/**
 *
 * @author Aki
 */
public class CategoryDAL extends DataAcessHelper{
     private final String GET_BY_ID="select * FROM Category where CatID= ?";
     private final String GET_ALL="select * from Category ";
     
    /* public ArrayList<Category> getbyID(int id){
         ArrayList<Category> objs= new ArrayList<>();
         try {
             getConnect();
             PreparedStatement ps = con.prepareStatement(GET_BY_ID);
             ps.setInt(1,id);
             ResultSet rs = ps.executeQuery();
             if(rs!=null&& rs.next()){
                 Category item= new Category();
                 item.setcatid(rs.getInt("CatID"));
                 item.setname(rs.getString("Name"));
                 objs.add(item);
             }
             getClose();
         } catch (Exception e) {
             JOptionPane.showMessageDialog(null, "Lỗi không đọc được CSDL");
         }
         
         return objs;
         
     }*/
    public ArrayList<Category> getByID(int id)
    {
        ArrayList<Category> objs = new ArrayList<>();
            try {
            getConnect();
                PreparedStatement ps= con.prepareStatement(GET_BY_ID);
                ps.setInt(1, id);
                ResultSet rs =ps.executeQuery();
                if(rs!=null&& rs.next())
                {
                    Category item= new Category();
                    item.setcatid(rs.getInt("CatID"));
                    item.setname(rs.getString("Name"));
                    objs.add(item);
                }
                getClose();
        } catch (Exception e) {
            e.printStackTrace();
        }
            return objs;
        }
    public ArrayList<Category> GetALL(){
        ArrayList<Category> objs = new ArrayList<>();
        try {
            getConnect();
            PreparedStatement ps= con.prepareStatement(GET_ALL);
            ResultSet rs = ps.executeQuery();
            if(rs!=null){
                while (rs.next()) {
                    Category item= new Category();
                    item.setcatid(rs.getInt("CatID"));
                    item.setname(rs.getString("Name"));
                    objs.add(item);
                }
            }
            getClose();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return objs;
    }
    
}
