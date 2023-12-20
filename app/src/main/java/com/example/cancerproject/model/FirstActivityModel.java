package com.example.cancerproject.model;

import java.lang.reflect.Constructor;

public class FirstActivityModel {
    int id;
    String img, text_main, text_add, img_arrow;

    public FirstActivityModel (int id, String img, String text_main, String text_add, String img_arrow){
        this.id= id;
        this.img = img;
        this.text_main = text_main;
        this.text_add = text_add;
        this.img_arrow = img_arrow;
    }
    public  String getImg_arrow() {return img_arrow;}
    public void setimg_arrow(String img_arrow) {this.img_arrow = img_arrow;}

    public int getId() {
        return id;
    }

    public String getImg() {
        return img;
    }

    public String getText_add() {
        return text_add;
    }

    public String getText_main() {
        return text_main;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setImg(String img) {
        this.img = img;
    }

    public void setText_add(String text_add) {
        this.text_add = text_add;
    }

    public void setText_main(String text_main) {
        this.text_main = text_main;
    }
}
