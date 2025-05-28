/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package DLL;

import DAL.CategoryDAL;
import Entity.Category;
import java.util.ArrayList;

/**
 *
 * @author Aki
 */
public class CategoryDLL {
    CategoryDAL cat = new CategoryDAL();
    public ArrayList<Category> getByID(int id){
        return cat.getByID(id);
    }
    public ArrayList<Category> getAll(){
        return  cat.GetALL();
    }
}
