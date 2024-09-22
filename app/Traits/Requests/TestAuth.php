<?php
namespace App\Traits\Requests;

trait TestAuth
{


  // ?todo rules of login for users
  protected function rulesLogin($field)
  {
    if ($field == "email") {
      return [
        "field" => "required|exists:users,email",
        "password" => "required"
      ];
    } else {
      return [
        "field" => "required|exists:users,name",
        "password" => "required"
      ];
    }
  }

  // ?todo rules of users registers
  protected function rulesRegist()
  {
    return [
      "name" => "required|min:4|max:20",
      "email" => "required|email|unique:users,email",
      "password" => "required|min:8",
    ];
  }
  // ?todo rules of store posts 
  protected function rulesContacts()
  {
    return [
      'message' => 'required|min:5|max:250',
    ];
  }

  // ?todo rules of Verify code of user
  protected function ruleCodeVerify()
  {
    return [
      'code' => 'required|exists:users,code',
      'email' => 'required|email|exists:users,email'
    ];
  }

  // ?todo rules of Change pass for users
  protected function ruleChangePass()
  {
    return [
      'password' => 'required|confirmed|min:8',
      'id' => 'required|exists:users,id'
    ];
  }

  // ?todo rules of send messages for chatgpt4 
  protected function rulesChatgpt4()
  {
    return [
      'message' => 'required|min:5|max:550',
    ];
  }

  // ?todo rules of send pdf file in python algorithm 
  protected function rulesPythonPdf()
  {
    return [
      'pdf' => 'required|max:2048,mimes:pdf,ppt,doc,docx',//? Corrected validation for document files 
    ];
  }

  protected function rulesStoreReusme()
  {

    return [
      'template_name' => 'nullable|string|max:255',
      'firstname' => 'nullable|string|max:255',
      'lastname' => 'nullable|string|max:255',
      'position' => 'nullable|string|max:255',
      'email' => 'nullable|email|max:255',
      'phone' => 'nullable|string|max:20',
      'experience' => 'nullable|string|max:255',
      'location' => 'nullable|string|max:255',
      'about' => 'nullable|string',
      'country' => 'nullable|string|max:255',
      'city' => 'nullable|string|max:255',
      'skills' => 'nullable|array',
      'social' => 'nullable|array',
    ];

  }

  // ?todo rules update users
  protected function rulesUpdateUsers()
  {
    return [
      'name' => 'required|min:4|max:20',
      "phone" => "required|numeric|digits:10",
      'birthday' => "required",
      "Personal_card" => "integer",
      'gender' => "required",
      'gmail' => "required|email"
    ];
  }

  // ?todo rules update users
  protected function rulessocialusers()
  {
    return [
      'name' => 'required|min:4|max:20',
      "phone" => "required|numeric|digits:10",
      'birthday' => "required",
      'gender' => "required",
    ];
  }


  // ?todo rules show bydate readings machines
  protected function rulesdate()
  {
    return [
      "created_at" => "required|date",
    ];
  }


  // ?todo rules store comments 
  protected function rulesComment()
  {
    return [
      'posts_id' => 'required|exists:posts,id',
      'comment' => 'required|min:5|max:200',
    ];
  }


  // ?todo rules store comments 
  protected function rulessms()
  {
    return [
      'country_code' => 'required|integer|digits_between:2,3',
      'phone' => 'required|numeric|digits:10|exists:users,phone'
    ];
  }

  // ?todo rules of type for users ?todo send mail
  protected function rulestype()
  {
    return [
      "type" => "required|max:12",
      "message" => "required|min:12"
    ];
  }









}