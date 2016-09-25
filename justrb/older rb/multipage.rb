require 'sinatra'
require 'sinatra/reloader' if development?


get '/luba' do
  "Vos sos mi Lubita"
end

get '/undermyskin' do
  "EXCPETIONAL Under My Skin 444"
 end
 
 get '/strangers' do
  "EXCPETIONAL Strangers 111"
 end
 
 get '/:name' do
  myname = params[:name]
  "Hi there #{myname}"
end