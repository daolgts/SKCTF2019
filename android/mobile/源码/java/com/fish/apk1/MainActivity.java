package com.fish.apk1;

import android.content.ContentValues;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import net.sqlcipher.Cursor;
import net.sqlcipher.database.SQLiteDatabase;
import static com.fish.apk1.p.q.qq;

public class MainActivity extends AppCompatActivity {

    ImageView imageView;
    String input;
    private  SQLiteDatabase db;
    String F_L_A_G;
    String KEY;

    private static final String TAG = "CATFISH";


    /**
     *
     */
    public void xx(){
        // 一定要在使用sqlite之前调用
        SQLiteDatabase.loadLibs(this);
        MyDatabaseHelper dbHelper = new MyDatabaseHelper(this, "test1.db", null, 1);


        String v1 = qq("hill");
        //数据库的密钥

        //KEY = "555555";
        KEY = v1;
        Log.i(TAG,v1);
        db = dbHelper.getWritableDatabase(KEY);

        ContentValues values = new ContentValues();
        values.put("name", "nicefish");
        values.put("pwd", 777);
        values.put("F_L_A_G", "SKCTF{hereistherealkey}");
        db.insert("SKCTF", null, values);
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);


        Button addData = (Button)findViewById(R.id.add_data);
        Button queryData = (Button)findViewById(R.id.query_data);

        addData.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

            }
        });

        xx();

        queryData.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Cursor cursor = db.query("SKCTF", null, null, null, null, null, null);
                if(cursor != null){
                    while(cursor.moveToNext()){
                        String name = cursor.getString(cursor.getColumnIndex("name"));
                        int pwd = cursor.getInt(cursor.getColumnIndex("pwd"));
                        F_L_A_G = cursor.getString(cursor.getColumnIndex("F_L_A_G"));
                        Log.d("TAG", "CTFer's name is " + name);
                        Log.d("TAG", "CTFer's pwd is " + pwd);
                        Log.d("TAG", "CTFer's flag is " + F_L_A_G);
                    }
                    cursor.close();
                }
            }
        });

        imageView = (ImageView)findViewById(R.id.image1) ;
        imageView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                imageView.setImageResource(R.drawable.a2);
                Toast.makeText(getApplicationContext(),"请输入咒语把骚猪变回萌妹！",Toast.LENGTH_LONG).show();
            }
        });

        Button button1 = (Button)findViewById(R.id.button1);
        button1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                EditText text1 =(EditText)findViewById(R.id.editText);
                input = text1.getText().toString();

                if(input.equals(F_L_A_G)){
                    imageView.setImageResource(R.drawable.a1);
                    Toast.makeText(getApplicationContext(),"right!但这并不是真正的flag！",Toast.LENGTH_LONG).show();
                }
                else{
                    Toast.makeText(getApplicationContext(),"wrong!骚猪向你发送了死亡之吻!",Toast.LENGTH_LONG).show();
                }
            }
        });

        SharedPreferences.Editor v0 =this.getSharedPreferences("test",0).edit();
        v0.putString("Is_Encroty","1");
        v0.putString("Encrypted","SqlCipher");
        v0.putString("ver_sion","4_1_3");
        v0.apply();

    }
}
