# ruby code here
require 'sinatra'
require 'sinatra/reloader' if development?
require 'slim'
require 'sass'

get ('/styles.css'){scss :styles}

get '/' do
  slim :home
end

get '/about' do
  @title = "Alex te tiene agarrado"
  slim :about
end

get '/contact' do
  slim :contact
end

not_found do
  slim :not_found
 end
