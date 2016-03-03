require 'csv'
Bundler.require(:commandline)

namespace :database_values do
  desc "insert into states, cities and dmas "
  task :insert => [:environment] do
    
    State.delete_all
    CSV.foreach("test/fixtures/states.csv") do |row|
      State.create(:id => row[0], :name => row[1])
    end
    
    City.delete_all
    CSV.foreach("test/fixtures/cities.csv") do |row|
      City.create(:id => row[0], :state_id => row[1], :city_name => row[2])
    end
    
    Dma.delete_all
    CSV.foreach("test/fixtures/dmas.csv") do |row|
      Dma.create(:id => row[0], :name => row[1], :city_id => row[2])
    end
    
    Offervalue.delete_all
    CSV.foreach("test/fixtures/offervalues.csv") do |row|
      Offervalue.create(:id=>row[0], :time=>row[1], :monday=>row[2], :tuesday=>row[3], :wednesday=>row[4],
                       :thursday=>row[5], :friday=>row[6], :saturday=>row[7], :sunday=>row[8])
    end
        
  end
end
