require  File.expand_path('./credential.rb', File.dirname(__FILE__))



support = AWS::Support::Client.new()
ta = support.describe_trusted_advisor_checks(:language => 'ja')
file = "trusted-advisor.json"

File.open(file, "r+") do |file|
    file.write(ta)
end


p ta.checks[0].id

p ta.checks[0].name
p '----------------'
p ta.checks[0].description
p '----------------'
p ta.checks[0].category  
p '----------------'
ta.checks[0].metadata.each do|meta|
  p meta
end
