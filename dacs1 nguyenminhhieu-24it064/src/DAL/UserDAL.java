/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package DAL;

import Entity.User;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

/**
 *
 * @author Aki
 */
public class UserDAL extends DataAcessHelper{
    private final String GET_BY_ID="select * from UserKH where UserID=?";
    private final String GET_ALL="select * from UserKH";
     private final String ADD_DATA ="insert into UserKH(UserID,Fullname,Phone,Address,Age) values(?,?,?,?,?)";
    private final String REMOVE_DATA="Delete from UserKH where UserID=?";
    private final String UPDATE_DATA="Update UserKH set Fullname=?,Phone=?,Address=?,Age=? where UserID=?";
    public ArrayList<User> getbyID(int id)
    {
        ArrayList<User> objs = new ArrayList<>();
        try {
           getConnect();
            PreparedStatement ps = con.prepareStatement(GET_BY_ID);
            ps.setInt(1, id);
            ResultSet rs = ps.executeQuery();
            if(rs!= null && rs.next())
            {
                User item = new User();
                item.setUserid(rs.getInt("UserID"));
                item.setFulname(rs.getString("Fullname"));
                objs.add(item);
            }
            getClose();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return objs;
    }
    public ArrayList<User> getAll()
    {
        ArrayList<User> objs = new ArrayList<>();
        try {
            getConnect();
            PreparedStatement pr = con.prepareStatement(GET_ALL);
            ResultSet rs=pr.executeQuery();
            if(rs!=null)
            {
                while (rs.next()) {
                User item = new User();
                item.setUserid(rs.getInt("UserID"));
                item.setFulname(rs.getString("Fullname"));
                item.setphone(rs.getString("Phone"));
                item.setaddress(rs.getString("Address"));
                item.setage(rs.getInt("Age"));
                objs.add(item);
                    
                }
            }
            getClose();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return objs;
    }
     public boolean AddData(User us)
    {
        boolean check = false;
        try{
            getConnect();
            PreparedStatement ps = con.prepareStatement(ADD_DATA);
            ps.setInt(1, us.getUserid());
            ps.setString(2, us.getFullname());
            ps.setString(3, us.getphone());
            ps.setString(4, us.getAddress());
            ps.setInt(5,us.getage());
      
            int rs=ps.executeUpdate();
            if(rs>0){
                check=true;
            }
            getClose();
        }catch(Exception e){
            e.printStackTrace();
        }
        return check;
    }
    public boolean DeleteData(int id){
        boolean check= false;
        try{
            getConnect();
            PreparedStatement ps = con.prepareStatement(REMOVE_DATA);
            ps.setInt(1, id);
            int rs=ps.executeUpdate();
            if(rs>0)
            {
                check=true;
            }
        }catch(Exception e){
         e.printStackTrace();
        }
        return check;
    }
     public boolean UpdateData(User us)
    {
        boolean check = false;
        try{
            getConnect();
            PreparedStatement ps = con.prepareStatement(UPDATE_DATA);
            //
            ps.setString(1, us.getFullname());
            ps.setString(2, us.getphone());
            ps.setString(3, us.getAddress());
            ps.setInt(4, us.getage());
            ps.setInt(5, us.getUserid());
            int rs=ps.executeUpdate();
            if(rs>0){
                check=true;
            }
            getClose();
        }catch(Exception e){
            e.printStackTrace();
        }
        return check;
    }
    
}
