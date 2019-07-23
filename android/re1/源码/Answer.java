package com.fish.test;
import java.util.*;

public class Answer {
	
	static String key = "SKCTF{reverseisfun}";
	
	//翻转字符串
	public static String hiahia(String str) {
		char [] array = str.toCharArray();
		int len = array.length;
		int half = (int)Math.floor(array.length/2);
		for(int i = 0; i < half; i++) {
			array[i] ^= array[len - i - 1];
			array[len - i - 1] ^= array[i];
			array[i] ^= array[len - i - 1];
		}
		return String.valueOf(array);
	}
	
	//int转换为二进制
	public static String heihei(int b) {
		String str = Integer.toBinaryString(b);
		while(str.length() < 8) {
			str += "0";
		}
		return str;
	}
	
	//1和0翻转
	public static String hehehe(String str) {
		String b = "";
		for (int i = 0; i < str.length(); i++) {
			if(str.charAt(i) == '0') {
				b += '1';
			}
			else {
				b += '0';
			}
		}
		return b;
	}
	
	//仍是翻转字符串
	public static String hohoho(String str) {
		if( str == null || str.equals(""))
			return str;
		List<Character> list = new ArrayList <Character>();
		for(char c: str.toCharArray())
			list.add(c);
		Collections.reverse(list);
		StringBuilder builder = new StringBuilder(list.size());
		for(Character c: list)
			builder.append(c);
		return builder.toString();
		
	}
	
	//字符串调序
	public static String hahaha(String str, int a) {
		String b = "";
		for (int i = a; i < str.length()+a; i ++) {
			b += str.charAt(i%str.length());
		}
		return b;
	}
	
	//还是翻转字符串
	public static String hihihi(String str) {
		if(str == null || str.equals(""))
			return str;
		byte[] bytes = str.getBytes();
		for(int i = 0, j = str.length()-1; i < j; i++, j--) {
			byte t = bytes[i];
			bytes[i] = bytes[j];
			bytes[j] = t;
		}
		return new String(bytes);
	}
	
	//转换过程
	public static String transformate(String str) {
		String ahaha = "";
		Stack<Integer> a = new Stack<Integer>();
		for(int j = 0; j < str.length(); j++) {
			int k = (int)str.charAt(j);
			a.push(k);
		}
		System.out.println(a);
		//翻转字符串
		for(int j = 0; j < str.length(); j++) {
			ahaha += heihei(a.pop());
		}
		System.out.println(ahaha);
		ahaha = hiahia(ahaha);
		System.out.println(ahaha);
		ahaha = hehehe(ahaha);
		System.out.println(ahaha);
		ahaha = hohoho(ahaha);
		System.out.println(ahaha);
		ahaha = hahaha(ahaha,7);
		System.out.println(ahaha);
		ahaha = hihihi(ahaha);
		System.out.println(ahaha);
		return ahaha;
	}
	
    
	public static void main(String[] args) {
		Answer.transformate(key);
	}
}
