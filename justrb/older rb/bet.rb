require 'sinatra'
require 'sinatra/reloader' if development?

get '/bet/:stake/on/:number' do
  stake  = params[:stake].to_i
  number = params[:number].to_i  
  roll = rand(6)+1
  if number == roll 
    "Die landed on #{roll} so you win #{6*stake} chips"
  else
	  "Die landed on #{roll} so you lose your stake of #{stake} chips"
  end
end