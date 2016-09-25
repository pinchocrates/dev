require 'sinatra'
require 'sinatra/reloader' if development?
get '/web21.rb' do
  "My Way 21"
end

get '/hello.rb' do
  "SANDMAN"
 end
 
 get '/mal' do
  "MALvado"
 end