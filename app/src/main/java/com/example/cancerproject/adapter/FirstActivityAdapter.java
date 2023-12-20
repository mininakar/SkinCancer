package com.example.cancerproject.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.example.cancerproject.FirstActivity;
import com.example.cancerproject.R;
import com.example.cancerproject.model.FirstActivityModel;

import java.lang.reflect.Constructor;
import java.util.List;

public class FirstActivityAdapter extends RecyclerView.Adapter<FirstActivityAdapter.OrderHolder> {
    Context context;
    List<FirstActivityModel> firstactivityorder;

    public FirstActivityAdapter( Context context, List<FirstActivityModel> firstactivityorder){
        this.context = context;
        this.firstactivityorder = firstactivityorder;
    }

    @NonNull
    @Override
    public OrderHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        //указываем дизайн к-ый будет использоваться для отображения
        View orderitems = LayoutInflater.from(context).inflate(R.layout.first_activity_item, parent, false);
        return new FirstActivityAdapter.OrderHolder(orderitems);
    }
    @Override
    public void onBindViewHolder(@NonNull OrderHolder holder, int position) {
            int imageid = context.getResources().getIdentifier(firstactivityorder.get(position).getImg(),"drawable", context.getPackageName());
            holder.orderImage.setImageResource(imageid);

            int orderImageArrowid = context.getResources().getIdentifier(firstactivityorder.get(position).getImg_arrow(), "drawable", context.getPackageName());
            holder.orderImageArrow.setImageResource(orderImageArrowid);

//            holder.orderImageArrow.setImageResource(firstactivityorder.get(position).getorderImageArrow());

            holder.orderText_main.setText(firstactivityorder.get(position).getText_main());
            holder.orderText_add.setText(firstactivityorder.get(position).getText_add());
    }

    @Override
    public int getItemCount() {
        return firstactivityorder.size();
    }

    public static final class OrderHolder extends RecyclerView.ViewHolder{

        ImageView orderImage;
        ImageView orderImageArrow;
        TextView orderText_main,orderText_add;

        public OrderHolder(@NonNull View itemView) {

            super(itemView);

            orderImage = itemView.findViewById(R.id.imageView);
            orderText_main = itemView.findViewById(R.id.textView_main);
            orderText_add = itemView.findViewById(R.id.textView_add);
            orderImageArrow = itemView.findViewById(R.id.orderImageArrow);
        }
    }

}
