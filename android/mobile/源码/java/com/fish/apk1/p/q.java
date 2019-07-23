package com.fish.apk1.p;
import static com.fish.apk1.m.n.encode;

public class q {
    private static String str1= "nicefish";

    public static String qq(String arg1){
        String a = encode(str1);
        a = a+arg1;
        return a.substring(15,19)+a.substring(40,44);
    }

    public String qqq(String arg1, String arg2){
        String a = encode(str1);
        a = a+arg1+arg2;
        return a.substring(20,23)+a.substring(44,48);
    }
}
